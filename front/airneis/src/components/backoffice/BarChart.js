import { useRef, useEffect, useState } from 'react';
import {
    Chart as ChartJS,
    CategoryScale,
    LinearScale,
    BarElement,
    Title,
    Tooltip,
    Legend,
} from 'chart.js';
import { Bar } from 'react-chartjs-2';
import { faker } from '@faker-js/faker';


function generateDataByDay() {
    return Array.from({ length: 7 }, () =>
        faker.datatype.number({ min: 0, max: 1000 })
    );
}

function generateDataByWeek() {
    return Array.from({ length: 5 }, () =>
        Array.from({ length: 7 }, () =>
            faker.datatype.number({ min: 0, max: 1000 })
        )
    );
}

function BarChart() {
    ChartJS.register(
        CategoryScale,
        LinearScale,
        BarElement,
        Title,
        Tooltip,
        Legend
    );

    const [data, setData] = useState({
        labels: ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'],
        datasets: [
            {
                label: 'Total des ventes',
                data: generateDataByDay(),
                backgroundColor: 'rgba(0, 128, 0, 0.5)',
            },
        ],
    });

    const options = {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Histogramme des ventes',
            },
        },
    };

    const chartRef = useRef(null);

    useEffect(() => {
        const chart = chartRef.current.chartInstance;

        function updateChart() {
            if (chart) {
                const newData = isTotalByWeek ? generateDataByWeek() : generateDataByDay();
                chart.data.datasets[0].data = newData;
                chart.update();
            }
        }

        let intervalId;

        if (isTotalByWeek) {
            intervalId = setInterval(updateChart, 5000);
        }

        return () => {
            clearInterval(intervalId);
        };
    }, []);

    const [isTotalByWeek, setIsTotalByWeek] = useState(false);

    const handleToggleTotal = () => {
        setIsTotalByWeek((prevState) => !prevState);
    };

    return (
        <div>
            <button onClick={handleToggleTotal}>
                {isTotalByWeek ? 'Total par jour' : 'Total par semaine (5 dernières semaines)'}
            </button>
            <Bar ref={chartRef} options={options} data={data} />
        </div>
    );
}

export default BarChart;
